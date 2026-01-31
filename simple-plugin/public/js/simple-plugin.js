// Simple Plugin JavaScript

/**
 * 查找容器元素
 */
function findContainer() {
    // 优先查找 #outer td，这是主要内容区域
    const container0 = document.querySelector("td#outer");
    if (container0) return container0;
    
    // 查找 td.embedded
    const container1 = document.querySelector("td.embedded");
    if (container1) return container1;
    
    // 查找 #outer 内的 main table
    const container2 = document.querySelector("#outer table.main tbody tr td");
    if (container2) return container2;
    
    // 查找 main table
    const container3 = document.querySelector("table.main tbody tr td");
    if (container3) return container3;
    
    // 查找宽度为100%的 table
    const container4 = document.querySelector("table[width=100%] tbody tr td");
    if (container4) return container4;
    
    // 查找任何 table 内的 td
    const container5 = document.querySelector("table tbody tr td");
    if (container5) return container5;
    
    // 查找任何 td 元素
    const container6 = document.querySelector("td");
    if (container6) return container6;
    
    // 查找 body
    const container7 = document.querySelector("body");
    if (container7) return container7;
    
    return null;
}

/**
 * 查找包含特定文本的元素
 */
function findElementContainingText(parent, tagName, text) {
    // 使用更高效的选择器策略
    const selector = tagName === "*" ? "*" : tagName;
    const elements = parent.querySelectorAll(selector);
    
    // 优化遍历逻辑，使用for循环而不是forEach
    for (let i = 0; i < elements.length; i++) {
        const element = elements[i];
        if (element.textContent && element.textContent.includes(text)) {
            return element;
        }
    }
    
    return null;
}

/**
 * 添加简单插件内容到首页
 */
function addSimplePluginContent(position, content) {
    // 执行容器查找
    const container = findContainer();

    if (container) {
        var simplePluginContent = document.createElement("div");
        simplePluginContent.innerHTML = content;
        
        // 默认插入位置：最近消息上方
        function insertDefault() {
            var recentNews = findElementContainingText(container, "h2", "最近消息");
            if (recentNews) {
                recentNews.parentNode.insertBefore(simplePluginContent, recentNews);
                return true;
            }
            // 如果最近消息也不存在，在容器底部插入
            container.appendChild(simplePluginContent);
            return true;
        }
        
        var inserted = false;
        
        switch (position) {
            case "disable":
                // 禁用：插件不显示
                return;
                
            case "top":
                // 顶部：插件显示在最近消息上方
                var recentNews = findElementContainingText(container, "h2", "最近消息");
                if (recentNews) {
                    recentNews.parentNode.insertBefore(simplePluginContent, recentNews);
                    inserted = true;
                } else {
                    // 备用：在容器顶部插入
                    container.insertBefore(simplePluginContent, container.firstChild);
                    inserted = true;
                }
                break;
                
            case "fun_box":
                // 趣味盒：插件显示在趣味盒上方
                var funBox = findElementContainingText(container, "h2", "趣味盒");
                if (funBox) {
                    funBox.parentNode.insertBefore(simplePluginContent, funBox);
                    inserted = true;
                } else {
                    inserted = insertDefault();
                }
                break;
                
            case "chat_box":
                // 群聊区：插件显示在群聊区上方
                var chatBoxTitle = findElementContainingText(container, "h2", "群聊区");
                if (chatBoxTitle) {
                    chatBoxTitle.parentNode.insertBefore(simplePluginContent, chatBoxTitle);
                    inserted = true;
                } else {
                    // 备用方案：查找群聊区iframe
                    var chatBoxIframe = document.querySelector("iframe#iframe-shout-box");
                    if (chatBoxIframe) {
                        var parentTable = chatBoxIframe.closest("table");
                        if (parentTable) {
                            parentTable.parentNode.insertBefore(simplePluginContent, parentTable);
                            inserted = true;
                        }
                    } else {
                        inserted = insertDefault();
                    }
                }
                break;
                
            case "vote":
                // 投票：插件显示在投票上方
                var vote = findElementContainingText(container, "h2", "投票");
                if (vote) {
                    vote.parentNode.insertBefore(simplePluginContent, vote);
                    inserted = true;
                } else {
                    inserted = insertDefault();
                }
                break;
                
            case "site_data":
                // 站点数据：插件显示在站点数据上方
                var siteData = findElementContainingText(container, "h2", "站点数据");
                if (siteData) {
                    // 显示在站点数据标题上方
                    siteData.parentNode.insertBefore(simplePluginContent, siteData);
                    inserted = true;
                } else {
                    inserted = insertDefault();
                }
                break;
                
            case "server_load":
                // 服务器负载：插件显示在服务器负载上方
                var serverLoad = findElementContainingText(container, "h2", "服务器负载");
                if (serverLoad) {
                    serverLoad.parentNode.insertBefore(simplePluginContent, serverLoad);
                    inserted = true;
                } else {
                    inserted = insertDefault();
                }
                break;
                
            case "disclaimer":
                // 免责条款：插件显示在免责条款上方
                var disclaimer = findElementContainingText(container, "h2", "免责条款");
                if (!disclaimer) {
                    disclaimer = findElementContainingText(container, "div", "免责条款");
                }
                if (!disclaimer) {
                    disclaimer = findElementContainingText(container, "p", "免责条款");
                }
                if (disclaimer) {
                    disclaimer.parentNode.insertBefore(simplePluginContent, disclaimer);
                    inserted = true;
                } else {
                    inserted = insertDefault();
                }
                break;
                
            case "friend_links":
                // 友情链接：插件显示在友情链接上方
                var friendLinks = findElementContainingText(container, "h2", "友情链接");
                if (friendLinks) {
                    friendLinks.parentNode.insertBefore(simplePluginContent, friendLinks);
                    inserted = true;
                } else {
                    inserted = insertDefault();
                }
                break;
                
            case "bottom":
                // 底部：插件显示在所有内容下方
                var friendLinks = findElementContainingText(container, "h2", "友情链接");
                if (friendLinks) {
                    // 查找友情链接h2标题后的table标签
                    var tables = [];
                    var sibling = friendLinks.nextElementSibling;
                    while (sibling) {
                        if (sibling.tagName === "TABLE") {
                            tables.push(sibling);
                        }
                        sibling = sibling.nextElementSibling;
                    }
                    
                    if (tables.length >= 2) {
                        // 存在2个或更多table标签时，在第二个标签前插入
                        tables[1].parentNode.insertBefore(simplePluginContent, tables[1]);
                        inserted = true;
                    } else if (tables.length === 1) {
                        // 只有一个table标签时，在第一个标签前插入
                        tables[0].parentNode.insertBefore(simplePluginContent, tables[0]);
                        inserted = true;
                    } else {
                        // 没有table标签时，在友情链接标题后插入
                        friendLinks.parentNode.insertBefore(simplePluginContent, friendLinks.nextSibling);
                        inserted = true;
                    }
                } else {
                    // 备用：在容器底部插入
                    container.appendChild(simplePluginContent);
                    inserted = true;
                }
                break;
        }
        
        // 最终备用：如果所有尝试都失败，使用默认插入
        if (!inserted) {
            inserted = insertDefault();
        }
    }
}

/**
 * 防抖函数
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * 节流函数
 */
function throttle(func, limit) {
    let inThrottle;
    return function executedFunction(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/**
 * 初始化插件
 */
function initializeSimplePlugin(position, content) {
    if (position === 'disable') {
        return;
    }
    
    // 使用防抖优化DOM操作
    const debouncedAddContent = debounce(() => {
        addSimplePluginContent(position, content);
    }, 100);
    
    // 确保DOM加载完成
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', debouncedAddContent);
    } else {
        debouncedAddContent();
    }
}

/**
 * 添加导航链接
 */
function addSimplePluginLink() {
    var mainMenu = document.querySelector("#mainmenu");
    if (mainMenu) {
        var simpleLi = document.createElement("li");
        var simpleLink = document.createElement("a");
        simpleLink.href = "simple-plugin.php";
        simpleLink.innerHTML = "&nbsp;Simple Plugin&nbsp;";
        simpleLi.appendChild(simpleLink);
        mainMenu.appendChild(simpleLi);
    }
}

// 导出函数
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        initializeSimplePlugin,
        addSimplePluginLink,
        findContainer,
        findElementContainingText,
        debounce,
        throttle
    };
}
